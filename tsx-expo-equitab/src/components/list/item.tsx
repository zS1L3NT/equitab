import { Text } from "react-native"
import { Row } from "react-native-ios-list"

type ListItemProps = {
	title: string
	subtitle?: string
	leading?: JSX.Element
}

export default function ListItem({ title, subtitle, leading }: ListItemProps) {
	return (
		<Row leading={leading}>
			<Text>{title}</Text>
			{subtitle && <Text className="mt-0.5 text-gray-400 text-xs">{subtitle}</Text>}
		</Row>
	)
}
