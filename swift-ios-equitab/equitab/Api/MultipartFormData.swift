import Foundation

// Adapted from https://gist.github.com/msanford1540/e8b6e5e85dd4a79c3f4867ec472fc1c9
protocol MultipartFormData {
    associatedtype Key: CodingKey
    var keyedBy: Key.Type { get }
    var boundary: String { get }
}

extension MultipartFormData {
    func toData() throws -> Data {
        var data = Data()

        for child in Mirror(reflecting: self).children {
            guard
                let label = child.label,
                let key = keyedBy.init(stringValue: label)?.stringValue
            else { continue }

            data.append("--\(boundary)--")
            data.append(.delimeter)

            switch child.value {
            case _ as String?: ()
            case let value as String:
                data.addFormField(name: key, value: value)

            case _ as Data?: ()
            case let value as Data:
                data.addFormField(name: key, value: value)

            case _ as Int?: ()
            case let value as Int:
                data.addFormField(name: key, value: String(value))

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

        data.append("--\(boundary)--")
        return data
    }
}

extension String {
    fileprivate static let delimeter = "\r\n"
}

extension Data {
    fileprivate mutating func append(_ string: String) {
        append(Data(string.utf8))
    }

    fileprivate mutating func addFormField(name: String, value: String) {
        append("Content-Disposition: form-data; name=\"\(name)\"")
        append(.delimeter)
        append(.delimeter)
        append(value)
        append(.delimeter)
    }

    fileprivate mutating func addFormField(name: String, value: Data) {
        append(
            "Content-Disposition: form-data; name=\"\(name)\"; filename=\"\(name)\""
        )
        append(.delimeter)
        append(.delimeter)
        append(value)
        append(.delimeter)
    }
}
