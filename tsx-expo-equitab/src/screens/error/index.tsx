import { Button, Text, View } from "react-native"

export default function ErrorScreen(props: { error: Error; resetError: () => void }) {
	return (
		<View>
			<Text>Error</Text>
			<Text>{props.error.toString()}</Text>
			<Button title="Try again" onPress={props.resetError} />
		</View>
	)
}
