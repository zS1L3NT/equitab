import Foundation

protocol ApiMultipartFormDataRequest: ApiRequest {
    associatedtype Key: CodingKey
    var keyedBy: Key.Type { get }
    var boundary: String { get }
}

extension Array where Element == Data {
    fileprivate mutating func append(_ newElement: String) {
        append(Data(newElement.utf8))
    }
}

extension ApiMultipartFormDataRequest {
    func toData(method: HttpMethod) throws -> Data {
        var lines: [Data] = []

        for child in Mirror(reflecting: self).children {
            guard
                let label = child.label,
                let key = keyedBy.init(stringValue: label)?.stringValue
            else { continue }

            lines.append("--\(boundary)")
            if child.value is Data {
                lines.append("Content-Disposition: form-data; name=\"\(key)\"; filename=\"\(key)\"")
            } else {
                lines.append("Content-Disposition: form-data; name=\"\(key)\"")
            }
            lines.append("")

            switch child.value {
            case Optional<Any>.none:
                // Remove the field if the value is null
                _ = lines.popLast()
                _ = lines.popLast()
                _ = lines.popLast()

            case let value as Encodable:
                lines.append(try JSONEncoder().encode(value))

            case let value as Int:
                lines.append(String(value))

            case let value as String:
                lines.append(value)

            case let value as Data:
                lines.append(value)

            default:
                throw EncodingError.invalidValue(
                    child.value as Any,
                    EncodingError.Context(
                        codingPath: [],
                        debugDescription: "Unsupported type"
                    )
                )
            }
        }

        // Soft override HTTP Method
        lines.append("--\(boundary)")
        lines.append("Content-Disposition: form-data; name=\"_method\"")
        lines.append("")
        lines.append(method.rawValue)

        lines.append(Data("--\(boundary)--".utf8))

        return Data(lines.joined(separator: Data("\r\n".utf8)))
    }
}
